import csv
import numpy as np
from sklearn.metrics import roc_auc_score
from sklearn.metrics.pairwise import cosine_similarity
from matcher import get_embedding

D = "eval/"
split = lambda x: [i.strip().lower() for i in x.split(";") if i.strip()]
read = lambda f: list(csv.DictReader(open(D + f, encoding="utf-8-sig")))

profiles = {r["id"]: r for r in read("profiles.csv")}
schols = {r["id"]: r for r in read("scholarships.csv")}
labels = [l for l in read("labels.csv") if l["label"].strip() in ("0", "1")]


def rules_score(p, s):
    deg = s["degree_level"].strip().lower()
    ok_deg = deg in ("", "any") or p["degree_level"].strip().lower() == deg
    ok_gpa = (not s["min_gpa"]) or (p["gpa"] and float(p["gpa"]) >= float(s["min_gpa"]))
    fields = split(s["eligible_fields"])
    ok_field = (not fields) or "any" in fields or p["field_of_study"].strip().lower() in fields
    return (ok_deg + bool(ok_gpa) + ok_field) / 3


def emb_score(p, s):
    summary = f"{p['field_of_study']}. Interests: {', '.join(split(p['interests']))}. Skills: {', '.join(split(p['skills']))}"
    return float(cosine_similarity(get_embedding(summary), get_embedding(s["description"]))[0][0])


rows = [(l["profile_id"], l["scholarship_id"], int(l["label"])) for l in labels]
y = np.array([r[2] for r in rows])
if len(set(y)) < 2:
    raise SystemExit("Need both label 1 and label 0 in labels.csv")
rules = np.array([rules_score(profiles[a], schols[b]) for a, b, _ in rows])
emb = np.array([emb_score(profiles[a], schols[b]) for a, b, _ in rows])
emb_n = (emb - emb.min()) / (emb.max() - emb.min() + 1e-9)


def best_acc(sc):
    return max(((sc >= t).astype(int) == y).mean() for t in np.unique(sc))


def p_at_3(sc):
    res = []
    for pid in set(r[0] for r in rows):
        idx = [i for i, r in enumerate(rows) if r[0] == pid]
        top = sorted(idx, key=lambda i: -sc[i])[:3]
        res.append(np.mean([y[i] for i in top]))
    return float(np.mean(res))


def report(name, sc):
    print(f"{name:<22} AUC={roc_auc_score(y, sc):.3f}  Acc={best_acc(sc):.3f}  P@3={p_at_3(sc):.3f}")


print(f"{len(rows)} labeled pairs, {y.mean():.0%} positive\n")
report("Rules only", rules)
report("Embeddings only", emb_n)
for w in np.arange(0.1, 1.0, 0.1):
    report(f"Blend (emb w={w:.1f})", w * emb_n + (1 - w) * rules)
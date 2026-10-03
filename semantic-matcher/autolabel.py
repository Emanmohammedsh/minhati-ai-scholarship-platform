import csv
D = "eval/"
split = lambda x: [i.strip().lower() for i in x.split(";") if i.strip()]
P = {r["id"]: r for r in csv.DictReader(open(D+"profiles.csv", encoding="utf-8-sig"))}
S = {r["id"]: r for r in csv.DictReader(open(D+"scholarships.csv", encoding="utf-8-sig"))}
rows = list(csv.DictReader(open(D+"labels.csv", encoding="utf-8-sig")))

for r in rows:
    p, s = P[r["profile_id"]], S[r["scholarship_id"]]
    deg = s["degree_level"].strip().lower()
    ok_deg = deg in ("", "any") or p["degree_level"].lower() == deg
    gpa_ok = (not s["min_gpa"]) or float(p["gpa"]) >= float(s["min_gpa"])
    fields = split(s["eligible_fields"])
    ok_field = (not fields) or "any" in fields or p["field_of_study"].lower() in fields
    r["label"] = "1" if (ok_deg and gpa_ok and ok_field) else "0"
    near = s["min_gpa"] and abs(float(p["gpa"]) - float(s["min_gpa"])) <= 0.3
    r["note"] = "REVIEW" if near else ""

with open(D+"labels.csv", "w", newline="", encoding="utf-8") as f:
    w = csv.DictWriter(f, fieldnames=["profile_id","scholarship_id","label","note"])
    w.writeheader(); w.writerows(rows)
pos = sum(r["label"] == "1" for r in rows)
print(f"{len(rows)} pairs, {pos/len(rows):.0%} positive")

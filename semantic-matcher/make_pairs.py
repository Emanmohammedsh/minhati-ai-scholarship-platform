import csv
D = "eval/"
p = [r["id"] for r in csv.DictReader(open(D + "profiles.csv", encoding="utf-8-sig"))]
s = [r["id"] for r in csv.DictReader(open(D + "scholarships.csv", encoding="utf-8-sig"))]
with open(D + "labels.csv", "w", newline="", encoding="utf-8") as f:
    w = csv.writer(f)
    w.writerow(["profile_id", "scholarship_id", "label"])
    for a in p:
        for b in s:
            w.writerow([a, b, ""])
print(len(p) * len(s), "pairs written to eval/labels.csv - fill label with 1 or 0")
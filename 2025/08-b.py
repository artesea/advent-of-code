import math
with open("2025/08-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

# tidy up the input in to rows of integers, plus build the base pots
circuits = []
rows = []
for x in range(len(lines)):
    row = [int(i) for i in lines[x].split(",")]
    rows.append(row)
    circuits.append([x])

# find the distances between all the point and sort shortest to longest
perms = []
for a in range(len(rows) - 1):
    for b in range(a+1, len(rows)):
        d = math.sqrt((rows[b][0] - rows[a][0])**2 + (rows[b][1] - rows[a][1])**2 + (rows[b][2] - rows[a][2])**2)
        perms.append([d, a, b])
perms.sort()

# keep adding wires until we break
for i in range(len(perms)):
    #need to find where the numbers are
    a = -1
    b = -1
    for j in range(len(circuits)):
        if perms[i][1] in circuits[j]:
            a = j
        if perms[i][2] in circuits[j]:
            b = j
    if a == -1 or b == -1:
        print("grr")
        continue
    if a == b:
        continue
    circuits[a] += circuits[b]
    circuits[b] = []
    if len(circuits[a]) == len(rows):
        break

print(f"The last two boxes were {rows[perms[i][1]]} and {rows[perms[i][2]]}")

answer = rows[perms[i][1]][0] * rows[perms[i][2]][0]

print(f"The answer is {answer}")
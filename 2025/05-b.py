with open("2025/05-input.txt") as in_file:
    input = in_file.read().strip()

lines = input.split("\n\n")[0].split("\n")
counter = 0
ranges = []
for line in lines:
    bits = line.split("-")
    ranges.append([int(bits[0]), int(bits[1])])

ranges.sort(key=lambda x: (x[0], x[1]))

new_ranges = []
new_ranges.append(ranges[0])
for i in range(1, len(ranges)):
    if ranges[i][0] >= new_ranges[-1][0] and ranges[i][0] <= new_ranges[-1][1]:
        if ranges[i][1] > new_ranges[-1][1]:
            new_ranges[-1][1] = ranges[i][1]
    else:
        new_ranges.append(ranges[i])

for r in new_ranges:
    #print(f"{r[0]}-{r[1]}")
    counter += r[1] + 1 - r[0]

print(f"The answer is {counter}")
with open("2025/07-input.txt") as in_file:
    input = in_file.read().strip().split("\n")

counter = 0
lines = []
for row in input:
    cols = list(row)
    for i in range(len(cols)):
        if cols[i] == "S":
            cols[i] = 1
        elif cols[i] == ".":
            cols[i] = 0
    lines.append(cols)

    
for y in range(len(lines)-1):
    for x in range(len(lines[0])):
        if lines[y][x] == "^":
            continue
        if lines[y][x] > 0:
            if lines[y+1][x] == "^":
                lines[y+1][x-1] += lines[y][x]
                lines[y+1][x+1] += lines[y][x]
            else:
                lines[y+1][x] += lines[y][x]

counter = sum(lines[-1])
print(f"The answer is {counter}")
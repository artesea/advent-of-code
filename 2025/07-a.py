with open("2025/07-input.txt") as in_file:
    input = in_file.read().strip().split("\n")

lines = [list(x) for x in input]

counter = 0

for y in range(len(lines)-1):
    for x in range(len(lines[0])):
        if lines[y][x] == "|" or lines[y][x] == "S":
            if lines[y+1][x] == ".":
                lines[y+1][x] = "|"
            elif lines[y+1][x] == "^":
                lines[y+1][x-1] = "|"
                lines[y+1][x+1] = "|"
                counter += 1

print(f"The answer is {counter}")
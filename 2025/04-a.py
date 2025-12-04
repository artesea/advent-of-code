with open("2025/04-input.txt") as in_file:
    rows = in_file.read().strip().split("\n")

counter = 0
height = len(rows)
width  = len(rows[0])
copy = []

for y in range(height):
    copy.append([])
    for x in range(width):
        copy[y].append(rows[y][x])
        if rows[y][x] != "@":
            continue
        nearby_rolls = 0
        for b in range(-1,2):
            if y+b < 0 or y+b >= height:
                continue
            for a in range(-1,2):
                if x+a < 0 or x+a >= width:
                    continue
                if a == 0 and b == 0:
                    continue
                if rows[y+b][x+a] == "@":
                    nearby_rolls += 1
        if nearby_rolls < 4:
            counter += 1
            copy[y][x] = "x"
    print("".join(copy[y]))
print(f"The answer is {counter}")
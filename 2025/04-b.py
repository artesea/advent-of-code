from copy import deepcopy
with open("2025/04-input.txt") as in_file:
    input = in_file.read().strip().split("\n")

copy = []
for y in range(len(input)):
    copy.append([*input[y]])

counter = 0
height = len(copy)
width  = len(copy[0])

while True:
    rows = deepcopy(copy)
    found_this_loop = 0

    for y in range(height):
        for x in range(width):
            if rows[y][x] != "@":
                copy[y][x] = "."
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
                found_this_loop += 1
                copy[y][x] = "x"
        #print("".join(copy[y]))
    counter += found_this_loop
    print(f"Found this loop {found_this_loop}")
    if found_this_loop == 0:
        break
print(f"The answer is {counter}")
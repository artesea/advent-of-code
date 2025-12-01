import math

with open("2025/01-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0
pointer = 50
for line in lines:
    debug = ""
    direction = line[0:1]
    rotation = int(line[1:])
    for i in range(rotation):
        if direction == "R":
            pointer = (pointer + 1) % 100
        elif direction == "L":
            pointer = (pointer - 1) % 100
        if pointer == 0:
            debug += "*"
            counter += 1
    debug = f"The dial is rotated {line} to point at {pointer} " + debug

    print(debug)
print(f"The answer is {counter}")

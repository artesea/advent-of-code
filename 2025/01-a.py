with open("2025/01-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0
pointer = 50
for line in lines:
    direction = line[0:1]
    rotation = int(line[1:])
    if direction == "R":
        pointer = (pointer + rotation) % 100
    elif direction == "L":
        pointer = (pointer - rotation) % 100
    if pointer == 0:
        counter += 1

print(f"The answer is {counter}")
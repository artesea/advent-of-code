with open("2025/03-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0
for line in lines:
    # find largest first number (remember to exclude the last value)
    first = 0
    first_index = 0
    for f in range(len(line) - 1):
        battery = int(line[f:][:1])
        if battery > first:
            first = battery
            first_index = f
    # find second largest number after the first
    second = 0
    for f in range(first_index + 1, len(line)):
        battery = int(line[f:][:1])
        if battery > second:
            second = battery
    counter += (first * 10) + second
    print(f"{line} {first}{second}")

print(f"The answer is {counter}")
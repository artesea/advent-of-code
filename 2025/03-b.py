with open("2025/03-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0
batteries_needed = 12
for line in lines:
    joltage = []
    current_index = -1
    for i in range(batteries_needed):
        joltage.append(0)
        for f in range(current_index+1, len(line) - (batteries_needed -1 - i)):
            battery = int(line[f:][:1])
            if battery > joltage[i]:
                joltage[i] = battery
                current_index = f
    found = int("".join(str(x) for x in joltage))
    counter += found
    print(f"{line} {found}")

print(f"The answer is {counter}")
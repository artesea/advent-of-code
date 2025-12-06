with open("2025/06-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0

operands = lines[-1].split()
solutions = [int(x) for x in lines[0].split()]
for line in lines[1:-1]:
    bits = line.split()
    for i in range(len(bits)):
        if operands[i] == "+":
            solutions[i] += int(bits[i])
        elif operands[i] == "*":
            solutions[i] *= int(bits[i])
        else:
            print("what are you doing here")
for sol in solutions:
    counter += sol

print(f"The answer is {counter}")
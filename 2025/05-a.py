with open("2025/05-input.txt") as in_file:
    input = in_file.read().strip()

ranges = input.split("\n\n")[0].split("\n")
ingredients = input.split("\n\n")[1].split("\n")

counter = 0
for i in ingredients:
    for r in ranges:
        if int(i) >= int(r.split("-")[0]) and int(i) <= int(r.split("-")[1]):
            counter += 1
            break

print(f"The answer is {counter}")
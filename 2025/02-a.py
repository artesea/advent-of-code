with open("2025/02-input.txt") as in_file:
    lines = in_file.read().strip().split(",")

counter = 0
for line in lines:
    #print(f"Checking {line}")
    r = line.split("-")
    for i in range(int(r[0]),int(r[1])+1):
        #print(f" {i}")
        l = len(str(i))
        if l % 2 == 1:
            # odd length ids
            continue
        if str(i)[:int(l/2)] == str(i)[int(l/2):]:
            #print(f"** {line} has invalid id {i}")
            counter += i

print(f"The answer is {counter}")
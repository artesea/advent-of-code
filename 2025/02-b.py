with open("2025/02-input.txt") as in_file:
    lines = in_file.read().strip().split(",")

counter = 0
for line in lines:
    #print(f"Checking {line}")
    r = line.split("-")
    for i in range(int(r[0]),int(r[1])+1):
        #print(f" {i}")
        id = str(i)
        l = len(id)
        for z in range(1, int((l/2))+1):
            if l // z != l / z:
                # not evenly broken up
                continue
            start = id[:z]
            found = True
            for g in range(z, l, z):
                chunk = id[g:][:z]
                if chunk != start:
                    found = False
                    break
            if found:
                #print(f"** {line} has invalid id {i}")
                counter += i
                break


print(f"The answer is {counter}")
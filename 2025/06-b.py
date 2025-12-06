with open("2025/06-input.txt") as in_file:
    lines = in_file.read().strip().split("\n")

counter = 0

operands = lines[-1].split()
col = 0
column_count = 0
debug = ""
for i in range(len(lines[0])):
    digit = ""
    for line in lines[:-1]:
        digit += line[i]
    if digit.strip() == "":
        #end of column, add to total
        print(f"{debug} = {column_count}")
        counter += column_count
        column_count = 0
        col += 1
    else:
        col_int = int(digit.replace(" ", ""))
        debug += f""
        if column_count == 0:
            debug = f"{col_int}"
            column_count = col_int
        elif operands[col] == "+":
            debug = f"{debug} + {col_int}"
            column_count += col_int
        elif operands[col] == "*":
            debug = f"{debug} * {col_int}"
            column_count *= col_int
        else:
            print("what are you doing here")
# need to add the last col on?
print(f"{debug} = {column_count}")
counter += column_count

print(f"The answer is {counter}")
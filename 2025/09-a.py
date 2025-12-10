import math
from datetime import datetime, timedelta
start_ts = datetime.now()
with open("2025/09-input.txt") as in_file:
    input = in_file.read().strip().split("\n")

# convert to list of ints
lines = []
for row in input:
    lines.append([int(i) for i in row.split(",")])

# compare areas
max_area = 0
for a in range(len(lines) - 1):
    for b in range(a, len(lines)):
        area = (abs(lines[a][0] - lines[b][0])+1) * (abs(lines[a][1] - lines[b][1])+1)
        max_area = max(max_area, area)

end_ts = datetime.now()
diff = (end_ts - start_ts) / timedelta(seconds=1)

print(f"The answer is {max_area} and took {diff} seconds")
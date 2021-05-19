import pandas as pd

path = "eb.csv"
df = pd.read_csv(path, error_bad_lines=False)

df = pd.concat([df['SONG_NAME'], df['similar_titles'].str.split('_', expand=True)], axis=1)

op = "export_B.csv"
df.to_csv(op, encoding="UTF-8")

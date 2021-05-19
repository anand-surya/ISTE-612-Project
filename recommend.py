import pandas as pd
from sklearn.feature_extraction import text
from sklearn.metrics.pairwise import cosine_similarity

# reading the lyrics csv file
# erroe_bad_lines will skip the rows with missing and damaged values
path = "azlyrics_lyrics_b.csv"
lyrics = pd.read_csv("azlyrics_lyrics_b.csv", error_bad_lines=False)

# extracting the lyrics from the file into a list

Text = lyrics['LYRICS'].tolist()

# vectorize the lyrics using scikit learn
# removing the stopwords

tfidf = text.TfidfVectorizer(input=Text, stop_words="english")

# standardize the score (zero mean and unit standard error)

matrix = tfidf.fit_transform(Text)

# printing the size of the vectors
# output = (no.of.rows in the dataset, no.of unique words in the dataset)

print("VECTOR MATRIX")
print(matrix.shape)

# finding the similar song based on the word of the lyrics using cosine similarity

similar_titles = cosine_similarity(matrix)


# function to return the "4" most similar song titles based on cosine similarity

def get_similar_articles(x):
    return "_".join(lyrics['SONG_NAME'].loc[x.argsort()[-5:-1]])


# calling the function to return the similar songs

lyrics['similar_titles'] = [get_similar_articles(x) for x in similar_titles]

# getting the songs and similar titles

header = ["SONG_NAME", "similar_titles"]

# writing the result to csv file
op = "export_B_RECOMMENDATION.csv"
lyrics.to_csv(op, columns=header)

# test cases

for x in range(0, 100):
    print("\nTest case %d" % x)
    print("Song Name: %s" % lyrics['SONG_NAME'].str.replace("_", " ").str.upper().str.strip()[x])
    print("Recommendation: %s" %
          lyrics['similar_titles'].str.replace("_", "\n").str.upper().str.strip().str.split("\n")[x])

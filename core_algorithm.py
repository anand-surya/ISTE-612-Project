"""
Author : Harshal Bendale
Author : Anand Surya
Author : Muriel Banze
Author : Saumya Nagia

Filename: last.py

Description:


"""

import sys
from collections import Counter

import nltk
import numpy as np
import pandas as pd
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
from nltk.tokenize import word_tokenize
import time

nltk.download('punkt')


def preprocess(lyrics):
    """

    :param lyrics:
    :return:
    """
    reg = "!\"#$%&()*+-./:;<=>?@[\]^_`{|}~\n"

    for _ in range(len(reg)):
        lyrics = np.char.replace(lyrics, reg[_], ' ')
        lyrics = np.char.replace(lyrics, " ", " ")

    lyrics = np.char.replace(lyrics, ',', '')
    np.char.replace(lyrics, "'", "")
    # ----------------------------------------------------------------------------
    np.char.lower(lyrics)
    # print(lyrics)
    stop_words = stopwords.words('English')
    words = word_tokenize(str(lyrics))

    new_text = ""
    for w in words:
        if w not in stop_words and len(w) > 1:
            new_text = new_text + " " + w

    # print(len(new_text))

    # -----------------------------------------------------------------------------
    stems = PorterStemmer()
    tok = word_tokenize(str(new_text))

    stemmed_lyrics = ""
    for _ in tok:
        stemmed_lyrics += " " + stems.stem(_)

    # print(type(stemmed_lyrics))
    return stemmed_lyrics


def calculate_DF(preprocssed_lyrics):
    """

    :param preprocssed_lyrics:
    :return:
    """
    doc_freq = {}
    # print(len(preprocssed_lyrics))
    for _ in range(len(preprocssed_lyrics)):
        tok = preprocssed_lyrics[_]
        # print(tok)
        for words in tok:
            try:
                doc_freq[words].add(_)
            except:
                doc_freq[words] = {_}

    for _ in doc_freq:
        doc_freq[_] = len(doc_freq[_])

    return doc_freq


def calculate_docFreq(doc_freq, word):
    """

    :param doc_freq:
    :param word:
    :return:
    """
    count = 0
    try:
        count = doc_freq[word]
    except:
        pass
    return count


def calculate_tf_IDF(preprocssed_lyrics, doc_freq):
    """

    :param preprocssed_lyrics:
    :param doc_freq:
    :return:
    """
    document = 0
    tf_idf_dict = {}

    for _ in range(len(preprocssed_lyrics)):
        toks = preprocssed_lyrics[_]
        c = Counter(toks)
        word_c = len(toks)

        for tok in np.unique(toks):
            tf = c[tok] / word_c
            df = doc_freq[tok]
            idf = np.log((len(preprocssed_lyrics) + 1) / (df + 1))

            tf_idf_dict[document, tok] = (tf * idf)
        document += 1

    return tf_idf_dict


def cosine_similarity(splitter, query, doc_freq, preprocessed_lyrics, tf_idf):
    """
    Finding the cosine similarity in this definition.

    :param splitter: Number of good hits
    :param query: query word to find
    :param doc_freq: dictionary of document, frequency
    :param preprocessed_lyrics: list form of preprocessed lyrics
    :param tf_idf: term frequency
    :return: cos_sim_matches : List of matches based on cosine similarity value
    """
    # print("Cosine Similarity")
   # processed_query = preprocess(query)
    #tok = processed_query

    # print("trying query:qqqqqqqqqqqqqqqqqqqq ", query)

    # print(tok)
    vocab = [_ for _ in doc_freq]
    cosine = []

    vector_query_value = np.zeros((len(vocab)))

    c = Counter(query)
    word_c = len(query)

    for toks in np.unique(query):
        try:
            tf = c[toks] / word_c
            df = doc_freq[toks]
            idf = np.log((len(query) + 1) / (df + 1))
        except:
            pass
        try:
            index = vocab.index(toks)
            vector_query_value[index] = tf * idf
        except:
            pass

    docu = np.zeros((len(preprocessed_lyrics), len(vocab)))
    for _ in tf_idf:
        try:
            index = vocab.index(_[1])
            docu[_[0]][index] = tf_idf[_]
        except:

            pass

    for _ in docu:
        cos_sim = np.dot(vector_query_value, _) / ((np.linalg.norm(vector_query_value) * np.linalg.norm(_)))
        cosine.append(cos_sim)
        #  print(cos_sim)
    cos_sim_matches = np.array(cosine).argsort()[-splitter:][::-1]

    # print("------------------------------------------------------------------------------------------------")

    print(cos_sim_matches)
    return cos_sim_matches


def main():
    """

    :return: None
    """
    file_path = sys.argv[1]

    colnames = ['Artist', 'Artist_URL', 'Song_Name', 'Song_URL', 'Lyrics']

    data = pd.read_csv(file_path, names=colnames)

    artist = data.Artist.tolist()
    song = data.Song_Name.tolist()
    lyrics = data.Lyrics.tolist()

    # print(len(artist))
    # print(len(song))
    # print(len(lyrics))

    start_time = time.time()

    size = 0
    preprocssed_lyrics = [None] * len(lyrics)
    for _ in range(len(lyrics)):
        preprocssed_lyrics[_] = word_tokenize(preprocess(lyrics[_]))
        size += len(preprocssed_lyrics[_])

    num_docs = len(lyrics)
    print("num docs ", num_docs)
    doc_freq = calculate_DF(preprocssed_lyrics)
    print(doc_freq["boot"])
    # print(len(doc_freq))
    # print(size)
    # print(preprocssed_lyrics)
    # print(len(preprocssed_lyrics))
    # vocabulary = [_ for _ in doc_freq]
    # print(vocabulary[:len(doc_freq)])

    tf_idf_dict = calculate_tf_IDF(preprocssed_lyrics, doc_freq)

    # print(tf_idf_dict[(2174, "ear")])
    for _ in preprocssed_lyrics:
        cos_sim = cosine_similarity(4, _, doc_freq, preprocssed_lyrics, tf_idf_dict)
    #print(cos_sim)
    print("--- %s seconds ---" % (time.time() - start_time))

if __name__ == '__main__':
    main()

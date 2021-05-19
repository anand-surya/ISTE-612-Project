# ISTE-612-Project
Music Recommendation System using NLP

We have created a rough model of the algorithm, and our original dataset contains 26+ CSV files with unstructured data in it (Each CSV file indicates A-Z letter organization of Artists’ names).
For testing purposes, we have used a letter B CSV file having 12,000+ records and for display purpose in console, we have displayed only the first 100 outputs of recommendations.
The results of the algorithm are exported into another CSV, with naming convention: ‘Export_ALPHABET_RECOMMENDATION.csv’.

# Example: 
# Input file: ‘AZLyrics_Lyrics_B.csv’ 
# Exported file: ‘Export_B_RECOMMENDATION.csv’
  
# Environment Settings:
Python package manager is required to successfully run the program.
For a python interpreter to get python packages installed, uninstalled and upgraded to a new package type the below command:
pip install
pip is used for managing project packages.
Another alternate to download python packages in using the below link:
https://pypi.org/project/bootstrap-py/
Python Installation - python -m pip install bootstrap - py

# Dependencies:
I.	Pandas: 
A.	Installation - pip install pandas
B.	Usage - import pandas as pd
II.	Scikit learn:
A.	Installation - pip install -U scikit-learn
B.	Usage -
1.	TFIDF - from sklearn.feature_extraction import text
2.	Cosine similarity - from sklearn.metrics.pairwise import cosine_similarity


Once the above requirements are fulfilled and the installation is done code could be written and executed without errors.

# Recommend.py
After executing the file, the program will produce output for 100 test cases. Also, the program will generate a csv file called ‘export_b123.csv’. The generated output file contains the recommendation for around 12,000 songs.  

# Core_algorithm.py
After executing the program will generate the 4 similar songs for each song in the dataset based on the lyrics.

# Split.py
After executing the program will split the similar titles’ column in the exported dataset into separate columns to be used in the database.


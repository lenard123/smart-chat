import sys
import os
import pandas as pd
from pandasai import SmartDatalake
from pandasai.llm import OpenAI

user_defined_path = os.getcwd()
llm = OpenAI(os.getenv("OPENAI_API_KEY"))
df1 = pd.read_csv("dataset/Addresses.csv", encoding="windows-1254")
df2 = pd.read_csv("dataset/BusinessPartners.csv", encoding="windows-1254")
df3 = pd.read_csv("dataset/Employees.csv", encoding="windows-1254")
df4 = pd.read_csv("dataset/ProductCategories.csv", encoding="windows-1254")
df5 = pd.read_csv("dataset/ProductCategoryText.csv", encoding="windows-1254")
df6 = pd.read_csv("dataset/Products.csv", encoding="windows-1254")
df7 = pd.read_csv("dataset/ProductTexts.csv", encoding="windows-1254")
df8 = pd.read_csv("dataset/SalesOrderItems.csv", encoding="windows-1254")
df9 = pd.read_csv("dataset/SalesOrders.csv", encoding="windows-1254")
dl = SmartDatalake([df1, df2, df3, df4, df5, df6, df7, df8, df9], config={"llm": llm, "save_logs": True, "enable_cache": False})

request = sys.argv[1]

print(dl.chat(request))

import pandas as pd
import numpy as np
import plotly.express as px
import plotly.graph_objects as go
import arabic_reshaper
from dash import Dash, dcc, html, Input, Output, callback
import dash_bootstrap_components as dbc

# Importing dataframe

df= pd.read_excel('raw_data.xlsx', dtype= {'تاریخ فاکتور' : str,
                                            'کد مشتری' : str})
df.dropna(subset= 'شماره فاکتور', inplace= True)
df['date_month']= df['تاریخ فاکتور'].str[:7]
df= df.sort_values(by= 'date_month')
#df['jalali_date']= df['تاریخ فاکتور'].jalali.parse_jalali("%Y/%m/%d")

from arabic_reshaper import reshape
#from bidi.algorithm import get_display
#labels= df['نام حوزه فروش']
#df['category']= [get_display(reshape(label)) for label in labels]
#names= df['نام مشتری']
#df['customer_name']= [get_display(reshape(name)) for name in names]


############################################### Sales by Category #####################################################

dff= df.groupby('نام حوزه فروش')['شماره فاکتور'].nunique()
dff= dff.sort_values(ascending= False)
fig_sales_by_category = go.Figure()
fig_sales_by_category.add_trace(
    go.Bar(
    x= dff.index,
    y= dff.values
    )
    )
fig_sales_by_category.update_layout(
    title= 'Sales by Category',
    template= 'plotly_dark',
    xaxis= dict(title= 'Category'),
    yaxis= dict(title= 'Sales'),
    )
#fig_sales_by_category.update_xaxes(category_order='total ascending')

dff= df.pivot_table(index= 'date_month',
                    values= 'شماره فاکتور',
                    columns= 'نام حوزه فروش',
                    aggfunc= {
                        'شماره فاکتور' : 'nunique'
                    })
dff= dff.reset_index()
dff= dff.melt(id_vars= ['date_month'],
              value_vars= dff.columns[2:])
categories= df['نام حوزه فروش'].unique()

fig_sales_by_category_trend= go.Figure()
for category in categories:
    table= dff[dff['نام حوزه فروش'] == category].drop(columns= 'نام حوزه فروش')
    table= table.groupby('date_month')['value'].sum()
    x= table.index
    y= table.values
    fig_sales_by_category_trend.add_trace(go.Scatter(x=x, y=y, name=category, mode="lines"))
    fig_sales_by_category_trend.update_layout(title="Sales Trend By Category",
                                  xaxis= dict(title='Month'),
                                  yaxis= dict(title='Sales'),
                                  template= 'plotly_dark')

############################################### Sales by Agent #####################################################

dff= df.dropna(subset= ['نام واسط/کارمند فروش'])

#agents= dff['نام واسط/کارمند فروش']
#dff['agent']= [get_display(reshape(agent)) for agent in agents]
agents= dff['نام واسط/کارمند فروش'].unique()
dfff= dff.groupby('نام واسط/کارمند فروش')['شماره فاکتور'].nunique()
dfff= dfff.sort_values(ascending= False)
fig_sales_by_agent= go.Figure()
fig_sales_by_agent.add_trace(go.Bar(
    x= dfff.index,
    y= dfff.values
    )
)
fig_sales_by_agent.update_layout(
    title= 'Sales by Agent',
    xaxis= dict(title= 'Agent'),
    yaxis= dict(title= 'Sales'),
    template= 'plotly_dark'
    )
#fig_sales_by_category.update_xaxes(category_order='total ascending')

dff= df.dropna(subset= ['نام واسط/کارمند فروش'])
dff= df.pivot_table(index= 'date_month',
                    values= 'شماره فاکتور',
                    columns= 'نام واسط/کارمند فروش',
                    aggfunc= {
                        'شماره فاکتور' : 'nunique'
                    })
dff= dff.reset_index()
dff= dff.melt(id_vars= ['date_month'],
              value_vars= dff.columns[2:])

fig_sales_by_agent_trend= go.Figure()
agents= df['نام واسط/کارمند فروش'].unique()

for agent in agents:
    table= dff[dff['نام واسط/کارمند فروش'] == agent].drop(columns= 'نام واسط/کارمند فروش')
    table= table.groupby('date_month')['value'].sum()
    x= table.index
    y= table.values
    fig_sales_by_agent_trend.add_trace(go.Scatter(x=x, y=y, name=agent, mode="lines"))
    fig_sales_by_agent_trend.update_layout(title="Sales Trend By Agent",
                                  xaxis= dict(title='Month'),
                                  yaxis= dict(title='Sales'),
                                  template= 'plotly_dark')


############################################### Sales by Customers #####################################################

dff= df.groupby(['نام مشتری'])['شماره فاکتور'].nunique()
dff= dff.sort_values(ascending= False)
top_customers= dff.head(12)

fig_sales_by_customers= go.Figure()
fig_sales_by_customers.add_trace(
    go.Bar(
    x= top_customers.index,
    y= top_customers.values
    )
    )
fig_sales_by_customers.update_layout(
    title= 'Sales by Top Customers',
    xaxis= dict(title= 'Customers'),
    yaxis= dict(title= 'Sales'),
    template= 'plotly_dark'
    )


dff= df.pivot_table(index= 'date_month',
                    values= 'شماره فاکتور',
                    columns= 'نام مشتری',
                    aggfunc= {
                        'شماره فاکتور' : 'nunique'
                    })
dff= dff.reset_index()
dff= dff.melt(id_vars= ['date_month'],
              value_vars= dff.columns[2:])

fig_sales_by_customers_trend= go.Figure()
customers= df['نام مشتری'].unique()
for customer in customers:
    table= dff[dff['نام مشتری'] == customer].drop(columns= 'نام مشتری')
    table= table.groupby('date_month')['value'].sum()
    x= table.index
    y= table.values
    fig_sales_by_customers_trend.add_trace(go.Scatter(x=x, y=y, name=customer, mode="lines"))
    fig_sales_by_customers_trend.update_layout(title="Sales Trend By customers",
                                      xaxis= dict(title='Month'),
                                      yaxis= dict(title='Sales'),
                                      template= 'plotly_dark')

app = Dash(__name__, external_stylesheets=[dbc.themes.DARKLY])

# Set up the app layout
app.layout = dbc.Container([
    dbc.Row([
        dbc.Col(html.H1("My Dash App"), className="DARKLY")
    ]),
    html.H1('Sales by Category'),
    dcc.Graph(figure= fig_sales_by_category, style={'width': '40%', 'display': 'inline-block'}),
    dcc.Graph(figure= fig_sales_by_category_trend, style={'width': '60%', 'display': 'inline-block'}),

    html.H1("Sales by َAgent"),
    dcc.Graph(figure= fig_sales_by_agent, style={'width': '40%', 'display': 'inline-block'}),
    dcc.Graph(figure= fig_sales_by_agent_trend, style={'width': '60%', 'display': 'inline-block'}),

    html.H1("Sales by Customers"),
    dcc.Graph(figure= fig_sales_by_customers, style={'width': '40%', 'display': 'inline-block'}),
    dcc.Graph(figure= fig_sales_by_customers_trend, style={'width': '60%', 'display': 'inline-block'}),
])

if __name__ == "__main__":
    app.run_server(debug=True)


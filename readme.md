An API that provides statistics about a specific Twitter account.

To view data about the cumulative tweets for a Twitter account, go to 

  http://localhost:8000/users?name='username'

and replace the username with the handle of the account you want to query.


To view data about the favorites and retweets per day during a given timerange, go to 

  http://localhost:8000/retweets?startdate='yyyy-mm-dd'&enddate='yyyy-mm-dd'&name='username'

  http://localhost:8000/favorites?startdate='yyyy-mm-dd'&enddate='yyyy-mm-dd'&name='username'

and replace the username with the handle of the account you want to query.
# Open Beer Database API Implementation

A PHP Implementation of the OpenBeerDatabase (http://openbeerdatabase.com)

## What is this about?

Well it's about keeping an open database of beers. This is great for beer
lovers all over the place. This works best if all beers are in the same
database but the main code has been left open so that anyone can create their
own database.

## The main database is at api.openbeerdatabase.com, can I use this on my server?

This implementation allows someone to make calls back to their own server by
changing the configuration in their calls
  <pre>OpenBeerDB\Configuration::$OpenBeerURI = "http://example.com";</pre>

## How can I help?

Open source works best if people are willing to help out. Take a look at the
Open Beer Database found at http://openbeerdatabase.com and on github at 
https://github.com/openbeerdatabase/openbeerdatabase

## TODO

This implementation doesn't yet allow for adding or updating objects. That's
coming soon.

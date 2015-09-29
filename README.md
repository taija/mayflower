# Bellevue College Mayflower Theme
Mayflower is a WordPress theme created by Bellevue College as a unified theme for all college units.

## Requirements
Mayflower has the following dependencies:

1. [WordPress Multisite](http://codex.wordpress.org/Create_A_Network)
2. Globals Style Library (must be available on the same server)
3. [Compass](http://compass-style.org/) installed on development systems

Specific configuration and release information is available in [Bellevue College Docs](https://github.com/BellevueCollege/docs/tree/master/mayflower). 

## Migrating from BC Gitolite Repository
As of 2015-09-29 Mayflower has moved to GitHub. Some configuration changes are needed to connect to this new repository.

1. [Update Origin's remote URL](https://help.github.com/articles/changing-a-remote-s-url/).  
   Command should be `git remote set-url origin git@github.com:BellevueCollege/mayflower.git`
2. Update branches through `git pull`
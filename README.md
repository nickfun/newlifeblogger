NewLife Blogger 
===============

About
-----

Hello I am Nick and I made this thing. Newlife Blogger was a project I made 
many years ago as a hobby. A friend of mine wanted to offer blogging service
to his online community, and asked me to setup something. I was going to 
just use livejournal as it is an open source project, but LJ is a huge system
and I wasn't qualified to set it up and it would have been overkill anyway. So
instead I made my own simple clone of Live Journal and we called it NewLife 
Blogger after the community my friend ran.

The project is no longer maintained, but it was my first big project and I was
rather proud of it at the time. I had to deal with managing files, validating
email addresses, banning unruly users, and letting people express themselves with
custom themes. The software was used on a few other sites, the biggest was a 
gaming community that had about 3000 users. 

Tech Used
---------

The biggest outside library that I used was the ETS template system. While not
the fastest template system it had some cool features that I needed. Also, I 
really liked its "mask" system. You could divide up the template into logical 
parts from the developers side and from the designers side. Also, I think I was
the biggest project to use ETS, as the author of the library added some special 
features when he noticed that I had modified ETS to prevent users from executing
PHP code within the templates.

Within the system I wrote several classes to handle core ideas in NLB, such
as blogs, users, email, and database connections/queries. At the time I thought
I was pretty hot because I was doing it OOP style. I didn't realize that I was
basically writing models and following MVC in an unenforced way. 

If you looking through the code and think that the techniques look like an
amature, that is because I was at the time. Also, the code was written to work 
on PHP 4.x since this was way before version 5 came out.
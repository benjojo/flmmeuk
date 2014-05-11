flmmeuk
=======

This is the site sourcecode to flm.me.uk

This site was made a solution to the (at the time more so) major annoyance with sending browser video down.

The idea is that you upload the video in any normal format and on the backend it will convert it to MP4, WebM and a GIF for fallback. After that it will give you back 2 BBCode tags for the primary use on facepunch.com that when a user visits, will pick the correct format to view.

In the case that the user does *not* have the ability to view the webm video, the image link will show a gif version of the video, at other times it just sends back a 1x1 "pixel" gif.

The code is really quite problematic and the reason this is open source is to get me to actually have motivation to fix it.
Theme-Mentor
============

Theme Mentor - helper plugin for WordPress, the cousin of Theme-Check reporting other possible theme issues

Theme Mentor is quite similar to Theme-Check. It iterates all .php files - your root theme folder template
files and your includes in inner folders (plus functions.php).

Different checks are being run to ensure the code quality of the theme. Theme-Check is more or less
trustworthy, it does report valid theme errors or missing features most of the time, but it is missing
most of the eventual issues in a theme.

What Theme Mentor does in addition is reporting everything that might or might not be suspicious. The average
success rate is about 70%, but it serves as a reminder for common WPTRT review remarks for you to double check.
After all, you don't lose anything. If you verify the report from Theme Mentor, you would either: a) confirm
that your code base is in tact, or: b) fix a nasty error that Theme-Check is afraid to report (fault tolerance issues).

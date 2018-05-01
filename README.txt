*********************

README

Visitor_admin files   Visitor_admin b0.95


********************


-----------------------
----- Beta 0.95 ------- 
-----------------------

Upgrades and clean up, new features and installer implementation

	- Created a web-based installer. Creates necessary files and initial database

	- Now supports label barcode printing (3x2 initially).  Can choose between fixed ID cards and printed labels. 
		**Kiosk mode for browser required if printing labels. See site for assistance

	- Enables choice of Modes: Visitors only, Volunteers only, or both

	- Enables choice of Volunteer registration: done at reception / admin / office or self registration

	- Allows for choice of use of group memberships for tracking of volunteers.  Recommended off if self-registration is used

	- Changed code for future upgrades
	
	- Overall clean up of initial code. Found several places where things were "hard-coded".  (oops-hence the beta-eek)



-----------------------
----- Beta 0.85.1 ----- 
-----------------------

Code Cleanup. Still more to do.


-----------------------
----- Beta 0.8.5 ----- 
-----------------------

* Created a Desk user ability to edit and log out delinquent volunteers.  Under "Whose Here", any administrator type can log someone out if the person forgot.  Also has the ability to edit delinquent volunteers beyond the same day.  It the delinquency is the same day as it's being addressed, the desk person can either log them out with the current time or select the closest time (within 15 minutes).  It resets the barcode status and if the time was volunteering, adds to their account.

* Eliminated a couple of bugs and cleaned up some php screen presentation

-----------------------
---Base Beta - 0.8.0--- 
-----------------------
MIT License
Copyright (c) 2018 BSconsulting - Baxter Shaffer bstechconsult@gmail.com<br><br>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

BY INSTALLING THIS SOFTWARE, I AGREE TO ALL OF THE ABOVE TERMS WITHOUT RESERVATION.

----------------------------------------  
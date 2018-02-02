function calendar(day, month, year)
{       
        if(year<=200)
        {
                year += 1900;
        }
        months = new Array('Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος');
        days_in_month = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
        if(year%4 == 0 && year!=1900)
        {
                days_in_month[1]=29;
        }
			
        total = days_in_month[month];
		
        var date_today = day+' '+months[month]+' '+year;
        beg_j = date;
        beg_j.setDate(1);
        if(beg_j.getDate()==2)
        {
                beg_j=setDate(0);
        }
        beg_j = beg_j.getDay();
        document.write('<div id="tableForm"><div class="sum_table">');
        document.write('<table><tr><td style="width:44px;"> << </td><td style="width:44px;"> <button id="button" style="width:44px; color: #FFFFFF;font-size:20px;font-family:Verdana;background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;"> >> </button> </td>');
		document.write('<td>' +months[month]+'  '+year+ '</td><td style="width:120px;"> Σήμερα </td></tr></table></div></div>');
		document.write('<body><div id="tableForm" style="margin-top:20px;"><div class="sum_table">');
		document.write('<table><tr><td>Κυριακή</td><td>Δευτέρα</td><td>Τρίτη</td><td>Τετάρτη</td><td>Πέμπτη</td><td>Παρασκευή</td><td>Σάββατο</td></tr>');
        week = 0;
        for(i=1;i<=beg_j;i++)
        {
                document.write('<td>'+(days_in_month[month-1]-beg_j+i)+'</td>');
                week++;
        }
        for(i=1;i<=total;i++)
        {
                if(week==0)
                {
                        document.write('<tr>');
                }
                if(day==i)
                {
                        document.write('<td>'+i+'</td>');
                }
                else
                {
                        document.write('<td>'+i+'</td>');
                }
                week++;
                if(week==7)
                {
                        document.write('</tr>');
                        week=0;
                }
        }
        for(i=1;week!=0;i++)
        {
                document.write('<td>'+i+'</td>');
                week++;
                if(week==7)
                {
                        document.write('</tr>');
                        week=0;
                }
        }
        document.write('</table></div></div></body></html>');
        return true;
}


/*function refresh_calendar(day, month, year)
{       
        if(year<=200)
        {
                year += 1900;
        }
        months = new Array('Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος');
        days_in_month = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
        if(year%4 == 0 && year!=1900)
        {
                days_in_month[1]=29;
        }
			
        total = days_in_month[month];
		///////////////////////////
		var now = new Date();
if (now.getMonth() == 11) {
    var date = new Date(now.getFullYear() + 1, 0, 1);
} else {
    var date = new Date(now.getFullYear(), now.getMonth() + 1, 1);
}

var day = date.getDate();
							var month = date.getMonth();
							document.write(month);
							var year = date.getYear();
		///////////////////////////////
        var date_today = day+' '+months[month]+' '+year;
        beg_j = date;
        beg_j.setDate(1);
        if(beg_j.getDate()==2)
        {
                beg_j=setDate(0);
        }
        beg_j = beg_j.getDay();
		
        document.write('<body><div id="tableForm"><div class="sum_table">');
        document.write('<table><tr><td style="width:44px;"> << </td><td style="width:44px;"> <button id="button" onclick="refresh_calendar(day, month+1, year)" style="width:44px; color: #FFFFFF;font-size:20px;font-family:Verdana;background-color: Transparent;background-repeat:no-repeat;border: none;cursor:pointer;overflow: hidden;outline:none;"> >> </button> </td>');
		document.write('<td>' +months[month]+'  '+year+ '</td><td style="width:120px;"> Σήμερα </td></tr></table></div></div>');
		document.write('<body><div id="tableForm" style="margin-top:20px;"><div class="sum_table">');
		document.write('<table><tr><td>Κυριακή</td><td>Δευτέρα</td><td>Τρίτη</td><td>Τετάρτη</td><td>Πέμπτη</td><td>Παρασκευή</td><td>Σάββατο</td></tr>');
        week = 0;
        for(i=1;i<=beg_j;i++)
        {
                document.write('<td>'+(days_in_month[month-1]-beg_j+i)+'</td>');
                week++;
        }
        for(i=1;i<=total;i++)
        {
                if(week==0)
                {
                        document.write('<tr>');
                }
                if(day==i)
                {
                        document.write('<td>'+i+'</td>');
                }
                else
                {
                        document.write('<td>'+i+'</td>');
                }
                week++;
                if(week==7)
                {
                        document.write('</tr>');
                        week=0;
                }
        }
        for(i=1;week!=0;i++)
        {
                document.write('<td>'+i+'</td>');
                week++;
                if(week==7)
                {
                        document.write('</tr>');
                        week=0;
                }
        }
        document.write('</div></div></body></html>');
        return true;
}*/
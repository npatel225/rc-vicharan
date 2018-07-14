(function($){
	$.fn.flatCalendar = function(options){
		/* Establish our default settings */
		var settings = $.extend($.fn.flatCalendar.extend,options);
		$.fn.flatCalendar.buildCal(settings.year,settings.month);
	}
	
	/* Default Settings */
	$.fn.flatCalendar.extend={
		id:'flat-calendar',
		events: [],
		year: new Date().getFullYear(),
		no_event: 'No Event',
		month: new Date().getMonth(),
		selected_date : null,
		monthNames:['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		dayNames:['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'],
		buttonText:{
			prev: "&lsaquo;",
			next: "&rsaquo;",
			delete: "delete",
		}
	};
	
	$.fn.flatCalendar.searchObjects = function(obj, key, val){
			var objects = [];
			for (var i in obj) {
				if(!obj.hasOwnProperty(i)) continue;
				if(typeof obj[i]=='object'){objects=objects.concat($.fn.flatCalendar.searchObjects(obj[i], key, val));}
				else if(i==key && obj[key]==val){objects.push(obj);}
			}
			return objects;
		}
		
	/* Build Calendar */
	$.fn.flatCalendar.buildCal = function(year,month){
		$.fn.flatCalendar.extend.year=parseInt(year);
		$.fn.flatCalendar.extend.month=parseInt(month);
		var 
			settings    = $.fn.flatCalendar.extend,
			date        = new Date(),
			today       = date.getDate(),
			todayMonth  = date.getMonth(),
			todayYear   = date.getFullYear(),
			todayDate   = ''
			daysInMonth = new Array(31,28,31,30,31,30,31,31,30,31,30,31),
			cal         = '',
			week        = 0
		;
		/* add day in leap year */
		if(settings.year<=200){settings.year += 1900;}
		if((settings.year%4 == 0) && (settings.year!=1900)){daysInMonth[1]=29;}
		
		/* Add Zero in the number */
		this.addZero = function(string){
			return (string<10) ? '0'+string : string;
		}
		todayDate = (settings.selected_date!=null) ? settings.selected_date : todayYear+'-'+this.addZero(todayMonth+1)+'-'+this.addZero(today);
		/* Search in Objects */
		this.searchObjects = $.fn.flatCalendar.searchObjects;
		
		/* Add Event Indicator */
		this.eventIndicator = function(date){
			var data_search=this.searchObjects(settings.events,'date',date);
			if(data_search.length>0){
				return '<div class="flatcal-day-event"></div>';
			}
			else{return '';}
		}
		
		/* Write Calender Day Header */
		cal+='<thead><tr>';
		for(var a=0;a<settings.dayNames.length;a++){cal+='<th class="day-'+settings.dayNames[a]+'">'+settings.dayNames[a]+'</th>';}
		cal+='</tr></thead>';
		cal+='<tbody><tr>';
		
		/* Begain with adding last month day */
		var lastMonthDate = new Date(settings.year,settings.month,1);
		var lastMonthDay = lastMonthDate.getDay();
		var lastMonth = settings.month;
		for(i=1;i<=lastMonthDay;i++){
			if(settings.month==0){lastMonth=12;}
			/* Make Date */
			if(lastMonth==12){date=Math.abs(lastMonthDate.getFullYear()-1);}else{date=lastMonthDate.getFullYear();}
			date+='-'+this.addZero(Math.abs(lastMonth))+'-'+this.addZero((daysInMonth[lastMonth-1]-lastMonthDay+i));
			
			cal+='<td class="flatcal-day other-month flatcal-'+settings.dayNames[week]+'" data-date="'+date+'">'+(daysInMonth[lastMonth-1]-lastMonthDay+i)+this.eventIndicator(date)+'</td>';
			week++;
		}
		
		/* Start making month */
		for(var i=1;i<=daysInMonth[settings.month];i++){
			if(week==0){cal+='<tr>';}
			
			date=settings.year+'-'+this.addZero(Math.abs(settings.month+1))+'-'+this.addZero(i);
			
			if((today==i) && (todayMonth==settings.month) && (todayYear==settings.year)){cal+='<td class="flatcal-day flatcal-today flatcal-'+settings.dayNames[week]+'" data-date="'+date+'">'+i+this.eventIndicator(date)+'</td>';}
			else{cal+='<td class="flatcal-day flatcal-'+settings.dayNames[week]+'" data-date="'+date+'">'+i+this.eventIndicator(date)+'</td>';}
			
			week++;
			
			if(week==7){
				cal+='</tr>';
				week=0;
			}
		}
		
		/* Add Next month Day */
		for(i=1;week!=0;i++){
			var 
				nextYear=settings.year,
				nextMonth=Math.abs(settings.month+2)
			;
			if(settings.month==11){nextYear=Math.abs(settings.year+1);}
			if(nextYear>settings.year){nextMonth=1;}
			date=nextYear+'-'+this.addZero(nextMonth)+'-'+this.addZero(i);
			cal+='<td class="flatcal-day other-month flatcal-'+settings.dayNames[week]+'" data-date="'+date+'">'+i+this.eventIndicator(date)+'</td>';
			week++;
			if(week==7){
				cal+='</tr>';
				week=0;
			}
		}
		cal+='</tbody>';
		/* Rap in side the table */
		cal='<table id="flatcal-body">'+cal+'</table>';
		
		var 
			nextMonth='',
			nextYear='',
			prevMonth='',
			prevYear=''
		;
		if(settings.month==0){
			prevYear=Math.abs(settings.year-1);
			prevMonth=11;
			nextYear=settings.year;
			nextMonth=Math.abs(settings.month+1);
		}
		else if(settings.month==11){
			prevYear=settings.year;
			prevMonth=Math.abs(settings.month-1);
			nextYear=Math.abs(settings.year+1);
			nextMonth=0;
		}
		else{
			prevYear=settings.year;
			prevMonth=Math.abs(settings.month-1);
			nextYear=settings.year;
			nextMonth=Math.abs(settings.month+1);
		}
		/* Add Header */
		var header = '<table id="flatcal-header"><tbody><tr>';
		header+='<td id="flatcal-header-prev" data-year="'+prevYear+'" data-month="'+prevMonth+'">'+settings.buttonText.prev+'</td>';
		header+='<td id="flatcal-header-title" data-year="'+todayYear+'" data-month="'+todayMonth+'">'+settings.monthNames[settings.month]+' '+settings.year+'</td>';
		header+='<td id="flatcal-header-next" data-year="'+nextYear+'" data-month="'+nextMonth+'">'+settings.buttonText.next+'</td>';
		header+='</tr></tbody></table>';
		
		/* Click on Today's date */
		setTimeout(function(){$('.flatcal-day[data-date="'+todayDate+'"]').trigger('click');},10);
		/* Output the content */
		return $('#'+settings.id).html(header+cal+'<div id="flatcal-add"></div><ul id="flatcal-day-event"></ul>');
	}
	
	$(document).on('click','#flatcal-header td#flatcal-header-prev, #flatcal-header td#flatcal-header-title, #flatcal-header td#flatcal-header-next',function(){
		$(document).flatCalendar.buildCal($(this).attr('data-year'),$(this).attr('data-month'));
	});
	
	$(document).on('click','.flatcal-day',function(){
		var date = $(this).attr('data-date');
		$(this).parent().parent().find('.flatcal-day-active').removeClass('flatcal-day-active');
		$(this).addClass('flatcal-day-active');
		var day_event = $(document).flatCalendar.searchObjects($.fn.flatCalendar.extend.events,'date',date);
		var events='';
		var checkInBtn = '';
		var title = '';
		for(var a=0;a<day_event.length;a++){
			row = day_event[a];
			checkInBtn = (row['classes']=='vicharan') ? '<button type="button" data-button data-color="green" onClick="OM.Page.check_in({date: \''+date+'\',type: \'modal\', region: \''+row["region"]+'\', center: \''+row["center"]+'\', sabha: \''+row["sabha"]+'\', confirm: true, vicharan_id: \''+row["vicharan_id"]+'\'});"><i class="fa fa-map-marker"></i></button>' : '';
			
			checkInBtn += (row['classes']=='check_in') ? OM.Button.edit({page_name:'my-vicharan-comment',color:(row['vicharan_note_id']!='') ? 'dark-blue' : true,icon:true,attr:'data-href="'+OM.domain+'#vicharan-notes/edit/?'+row["index"]+'"'}) : '';
			
			title = '<strong>'+row["center"]+'</strong>'+((row["sabha"]!='') ? '('+row["sabha"]+')' : '')+' '+((row["region"]!='') ? ' - <em>'+row["region"]+'</em>' : '');

			events += '<li id="'+row['id']+'" data-date="'+row['date']+'" data-index="'+row['index']+'" data-borderleft="'+row['classes']+'" data-note_type="'+((row['vicharan_note_id']=='') ? 'new' : 'edit')+'">'+
				'<span class="detail">'+
					'<span class="title">'+title+'</span>'+
					'<span class="note">'+row['note']+'</span>'+
				'</span>'+
				'<span>'+checkInBtn+$.fn.flatCalendar.extend.buttonText.delete+'</span>'+
			'</li>';
		}
		$('#flatcal-add').html('<div class="text-center">'+
			'<button type="button" data-button data-color="dark-blue" onClick="OM.Page.plan_my_vicharan({date: \''+date+'\'});"><i class="fa fa-plus"></i>&nbsp;Plan new visit</button>'+
			'&nbsp;<button type="button" data-button data-color="green" onClick="OM.Page.check_in({date: \''+date+'\',type: \'modal\'});"><i class="fa fa-map-marker"></i>&nbsp;Check-in</button>'+
			'<button></button>'+
		'</div>').attr('data-card','');
		if(events){
			$('#flatcal-day-event').html(events).attr('data-card','');
		}else{
			$('#flatcal-day-event').html('').removeAttr('data-card');
		}
	});
	
}(jQuery));
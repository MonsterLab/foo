function showTimePanel(documentname){
$("#"+documentname).datetimepicker({dateFormat:'yy-mm-dd',altFormat:'yy-mm-dd' ,showAnim:"fadeIn",duration:0,minDate: "-10y", maxDate:"2y",numberOfMonths: 1,
    monthNamesShort: ['\u4E00\u6708','\u4E8C\u6708','\u4E09\u6708','\u56DB\u6708','\u4E94\u6708','\u516D\u6708','\u4E03\u6708','\u516B\u6708','\u4E5D\u6708','\u5341\u6708','\u5341\u4E00\u6708','\u5341\u4E8C\u6708'],
    monthNames: ['\u4E00\u6708','\u4E8C\u6708','\u4E09\u6708','\u56DB\u6708','\u4E94\u6708','\u516D\u6708','\u4E03\u6708','\u516B\u6708','\u4E5D\u6708','\u5341\u6708','\u5341\u4E00\u6708','\u5341\u4E8C\u6708'],//['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
    nextText: '\u4E0B\u4E00\u6708',
    prevText: '\u4E0A\u4E00\u6708' ,
    timeText: '\u65f6\u95f4',
    hourText: '\u65f6',
    minuteText: '\u5206',
    secondText: '\u79d2',
    currentText: '\u5f53\u524d\u65f6\u95f4',
    closeText: '\u5173\u95ed',
    showSecond: true,

   timeFormat: 'hh:mm:ss',

    dayNames: ['\u661F\u671F\u5929','\u661F\u671F\u4E00', '\u661F\u671F\u4E8C', '\u661F\u671F\u4E09', '\u661F\u671F\u56DB', '\u661F\u671F\u4E94', '\u661F\u671F\u516D'],//['星期天','星期一', '二', '三', '四', '五', '六'],'%u661F%u671F%u5929'
    dayNamesMin: ['\u65E5','\u4E00', '\u4E8C', '\u4E09', '\u56DB', '\u4E94', '\u516D']
    }); 
	
}
/**
 * Created by Administrator on 2016/7/25.
 */


define(["handlebars"], function(Handlebars){
    Handlebars.registerHelper('cal-td', function() {
        var str= '<tr class="thin-border">';
        for(var i= 0, count = this.beforeBlankCount; i<count; i++){
            str += '<td class="day-td disabled">&nbsp;</td>'
        }

        var dateLabel, jLabel;
        for(var j= 1, mTotalDay = this.monthDayCount; j<= mTotalDay; j++){
            i++;
            jLabel = j < 10 ? '0' + j : j;
            dateLabel = this.monthLabel + '-' + jLabel;

            if( j < this.todayMix ){
                str += '<td class="day-td earlier disabled ' + (dateLabel == this.today ? 'today': '') + '">'
                    + '<div>'+ j + '</div>'
                    + '<div class="price">&nbsp;</div>'
                    + '</td>';

            } else if (this.dates[dateLabel]){

                if (dateLabel == this.today){

                    str += '<td class="day-td today '+  (dateLabel == this.selectedDate ? 'selected': '') + '" data-key="'+ dateLabel +'">'
                    +'<div>今天</div>'
                    +'<div class="price">¥' + this.dates[dateLabel].startPrice +'<span>起</span></div>'
                    +'</td>';
                } else {
                     str += '<td class="day-td '+  (dateLabel == this.selectedDate ? 'selected': '') + '" data-key="'+ dateLabel +'">'
                     +'<div>' + (this.dates[dateLabel].festival || j) + '</div>'
                     +'<div class="price">¥ ' + this.dates[dateLabel].startPrice + '<span>起</span></div>'
                     +'</td>';
                }
            } else {
                str += '<td class="day-td disabled '+ (dateLabel == this.selectedDate ? 'today': '') + '">'
                +'<div>' + (dateLabel == this.today ? '今天': j) + '</div>'
                +'<div class="price">&nbsp;</div>'
                +'</td>';
            }
            if((i % 7 == 0)){
                str += ' </tr><tr>';
            }
        }
        str += '</tr>';
        return str;

    });
});


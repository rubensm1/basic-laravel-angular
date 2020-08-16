import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'formatadorData'
})
export class FormatadorDataPipe implements PipeTransform {

    transform(value: string, time?:boolean): string {
        var date:Date = new Date (value);
        return date.toLocaleDateString() + (time ? " " + date.toLocaleTimeString().substring(0,5) : '');
    }


    public static getDataAtual() {
        var d = new Date();
        d.setHours(0,0,0,0);
        return d;
    }

    public static getDataAmanha(data?:Date) {
        var d = data ? data : FormatadorDataPipe.getDataAtual();
        d.setDate(d.getDate() +1);
        return d;
    }
}

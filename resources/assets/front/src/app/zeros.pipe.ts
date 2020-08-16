import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
    name: 'zeros'
})
export class ZerosPipe implements PipeTransform {

    transform(value: number, casas: number): string {
        var character = "0"
        var s = String(value);
        while (s.length < (casas)) {
            s = character + s;
        }
        return s;
    }

}

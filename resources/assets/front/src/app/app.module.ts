import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Routes, RouterModule } from '@angular/router';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';

import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MessageService } from 'primeng/api';
import { TabViewModule } from 'primeng/tabview';
import { CalendarModule } from 'primeng/calendar';
import { MessagesModule } from 'primeng/messages';
import { MessageModule } from 'primeng/message';
import { InputMaskModule } from 'primeng/inputmask';
import { InputTextModule } from 'primeng/inputtext';
import { ButtonModule } from 'primeng/button';
import { CheckboxModule } from 'primeng/checkbox';
import { DropdownModule } from 'primeng/dropdown';
import { NgxViacepModule } from '@brunoc/ngx-viacep';
import { FileUploadModule } from 'primeng/fileupload';
import { RadioButtonModule } from 'primeng/radiobutton';
import { ToolbarModule } from 'primeng/toolbar';
import { CardModule } from 'primeng/card';
import { ToggleButtonModule } from 'primeng/togglebutton';
import { AccordionModule } from 'primeng/accordion';
import { FieldsetModule } from 'primeng/fieldset';
import { ToastModule } from 'primeng/toast';
import { SliderModule } from 'primeng/slider';
import { ScrollPanelModule } from 'primeng/scrollpanel';
import { AutoCompleteModule } from 'primeng/autocomplete';

import { UsuariosComponent } from './usuarios/usuarios.component';
import { CandidatoComponent } from './candidato/candidato.component';
import { TesteComponent } from './teste/teste.component';
import { ArquivosComponent } from './arquivos/arquivos.component';

import { ArquivosService } from './arquivos/arquivos.service';
import { UsuarioService } from './usuarios/usuario.service';
import { DadosService } from './dados.service';

import { RedimensionarDirective } from './redimensionar.directive';
import { FiltroUsuarioPipe } from './usuarios/filtro-usuario.pipe';
import { FormatadorDataPipe } from './formatador-data.pipe';
import { ZerosPipe } from './zeros.pipe';
import { HomeComponent } from './home/home.component';
import { ConfiguracoesComponent } from './configuracoes/configuracoes.component';
import { ConfiguracoesService } from './configuracoes/configuracoes.service';

const appRoutes: Routes = [
    { path: 'usuarios', component: UsuariosComponent },
    { path: 'eu', component: CandidatoComponent },
    { path: 'home', component: HomeComponent },
    { path: 'config', component: ConfiguracoesComponent },
    { path: 'teste', component: TesteComponent },
    /*{ path: '',
      redirectTo: '/',
      pathMatch: 'full'
    },*/
    { path: '**', component: HomeComponent }
];

@NgModule({
    declarations: [
        AppComponent,
        UsuariosComponent,
        CandidatoComponent,
        FiltroUsuarioPipe,
        RedimensionarDirective,
        ArquivosComponent,
        FormatadorDataPipe,
        TesteComponent,
        ZerosPipe,
        HomeComponent,
        ConfiguracoesComponent,
    ],
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        AppRoutingModule,
        RouterModule.forRoot(
            appRoutes,
            //{ enableTracing: true } // <-- debugging purposes only
        ),
        BrowserAnimationsModule,
        TabViewModule,
        CalendarModule,
        MessagesModule,
        InputTextModule,
        InputMaskModule,
        ButtonModule,
        DropdownModule,
        CheckboxModule,
        FileUploadModule,
        RadioButtonModule,
        FieldsetModule,
        ToastModule,
        AccordionModule,
        SliderModule,

        NgxViacepModule,
        ToolbarModule,
        CardModule,
        MessageModule,
        ToggleButtonModule,
        ScrollPanelModule,
        AutoCompleteModule
    ],
    providers: [
        UsuarioService,
        DadosService,
        MessageService,
        ArquivosService,
        ConfiguracoesService
    ],
    bootstrap: [AppComponent],
})
export class AppModule { }

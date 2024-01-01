import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { BooksService } from './services/books.service';
import { WeatherService } from './services/weather.service';
import { Book } from './interfaces/books.interface';
import { faPenToSquare } from '@fortawesome/free-solid-svg-icons';
import { faXmark } from '@fortawesome/free-solid-svg-icons';
import { ModalInsertComponent } from './modal/modal-insert.component';
import { ModalUpdateComponent } from './modal/modal-update.component';
import { ModalComponent } from './modal/modal-delete.component';
import { MdbModalRef, MdbModalService } from 'mdb-angular-ui-kit/modal';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
 /* styleUrls: ['./app.component.css'],*/
  providers: [BooksService]
})
export class AppComponent{


}

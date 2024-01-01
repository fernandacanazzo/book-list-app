import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { BooksService } from '../../services/books.service';
import { WeatherService } from '../../services/weather.service';
import { Book } from '../../interfaces/books.interface';
import { faPenToSquare } from '@fortawesome/free-solid-svg-icons';
import { faXmark } from '@fortawesome/free-solid-svg-icons';
import { ModalInsertComponent } from '../../modal/modal-insert.component';
import { ModalUpdateComponent } from '../../modal/modal-update.component';
import { ModalComponent } from '../../modal/modal-delete.component';
import { MdbModalRef, MdbModalService } from 'mdb-angular-ui-kit/modal';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
 /* styleUrls: ['./app.component.css'],*/
  providers: [BooksService]
})
export class HomeComponent implements OnInit{

  books: Book[] = [];
  weather = {
    city: '',
    temperature: '',
    condition_slug: ''
  }
  weatherImg: any;
  faPenToSquare = faPenToSquare;
  faXmark = faXmark;
  modalRef: MdbModalRef<any> | null = null;
  modalInsertRef: MdbModalRef<any> | null = null;
  modalUpdateRef: MdbModalRef<any> | null = null;

  textAlert: string | null = null;

  constructor(private booksService: BooksService, private WeatherService: WeatherService, private modalService: MdbModalService, private router: Router) {
  }

  ngOnInit(){

    this.loadBooks();
    //this.getWeather();
  }

  getWeather(){

    this.WeatherService.getWeather().subscribe({
      next: (response: any) => {
        this.weather = response;
        this.weatherImg = "https://assets.hgbrasil.com/weather/icons/conditions/" + this.weather.condition_slug + ".svg";
      }, error: (error) => {
        console.log(error);
      }
    });

  }

  loadBooks(){

    this.booksService.getBooks().subscribe({
      next: (response: Book[]) => {
        this.books = response;
      }, error: (error) => {
        
        this.router.navigateByUrl('/login'); 

      }
    });
    
  }

  modalDeleteBook(bookId: any) {

    this.modalRef = this.modalService.open(ModalComponent, {
      data: { id: bookId },
    });

    this.modalRef.onClose.subscribe((response: any) => {
      if(response){
        this.loadBooks();
        this.textAlert = response.message;
      } 
    });

  }

  modalInsertBook() {

    this.modalInsertRef = this.modalService.open(ModalInsertComponent);

    this.modalInsertRef.onClose.subscribe((response: any) => {
      if(response){
        this.loadBooks();
        this.textAlert = response.message;
      }
    });

  }

  modalUpdateBook(book: Book) {

    this.modalUpdateRef = this.modalService.open(ModalUpdateComponent, {
      data: { book: book },
    });

    this.modalUpdateRef.onClose.subscribe((response: any) => {
      if(response){
        this.loadBooks();
        this.textAlert = response.message;
      }
    });

  }

  logout(){

    localStorage.removeItem("token");
    this.router.navigateByUrl('/login'); 

  }

}

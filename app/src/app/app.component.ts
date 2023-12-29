import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { HttpHeaders } from '@angular/common/http';
import { BooksService } from './services/books.service';
import { Book } from './interfaces/books.interface';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [BooksService]
})
export class AppComponent implements OnInit{
  books: Book[] = [];

  constructor(private booksService: BooksService) {
  }

  ngOnInit(){
    this.booksService.getBooks().subscribe({
      next: (response: Book[]) => {
        this.books = response;
      }, error: (error) => {
        console.log(error);
      }
    });
  }

}

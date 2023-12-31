import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';
import { BooksService } from '../services/books.service';

@Component({
  selector: 'app-modal-insert',
  templateUrl: './modal-insert.component.html',
})
export class ModalInsertComponent {

  title: any;
  description: any;
  author: any;
  number_of_pages: any;
  date_insert: any;

  constructor(private booksService: BooksService, public modalInsertRef: MdbModalRef<ModalInsertComponent>) {}

  insertBook(){

    this.booksService.insertBook(this.title, this.description, this.author, this.number_of_pages, this.date_insert).subscribe({
      next: (response: any[]) => {
       
        this.modalInsertRef.close(response);
        console.log(response);

      }, error: (error) => {

        this.modalInsertRef.close(error);

      }
    });

  }

}
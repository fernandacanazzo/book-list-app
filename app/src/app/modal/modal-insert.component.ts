import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';
import { MdbFormControlComponent } from 'mdb-angular-ui-kit/forms';
import { BooksService } from '../services/books.service';

@Component({
  selector: 'app-modal-insert',
  templateUrl: './modal-insert.component.html',
})
export class ModalInsertComponent {

  constructor(private booksService: BooksService, public modalInsertRef: MdbModalRef<ModalInsertComponent>) {}

  /*deleteBook(bookId: any){

    this.booksService.deleteBook(bookId).subscribe({
      next: (response: any[]) => {
       
        this.modalRef.close(response);

      }, error: (error) => {

        this.modalRef.close(error);

      }
    });

  }*/

}
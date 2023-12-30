import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';
import { BooksService } from '../services/books.service';

@Component({
  selector: 'app-modal',
  templateUrl: './modal-delete.component.html',
})
export class ModalComponent {

  id: string | null = null;

  constructor(private booksService: BooksService, public modalRef: MdbModalRef<ModalComponent>) {}

  deleteBook(bookId: any){

    this.booksService.deleteBook(bookId).subscribe({
      next: (response: any[]) => {
       
        this.modalRef.close(response);

      }, error: (error) => {

        this.modalRef.close(error);

      }
    });

  }

}
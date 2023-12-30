import { Component } from '@angular/core';
import { MdbModalRef } from 'mdb-angular-ui-kit/modal';

@Component({
  selector: 'app-modal',
  templateUrl: './modal-delete.component.html',
})
export class ModalComponent {

  id: string | null = null;

  constructor(public modalRef: MdbModalRef<ModalComponent>) {}
}
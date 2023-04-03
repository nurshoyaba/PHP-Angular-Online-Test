import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ReactiveFormsModule, FormsModule } from "@angular/forms";

import { AddUserComponent  } from './add-user.component';

describe('AddUserComponent: Login', () => {
  let component: AddUserComponent;
  let fixture: ComponentFixture<AddUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ReactiveFormsModule, FormsModule],
      declarations: [ AddUserComponent ]
    })
    .compileComponents();
    // create component and test fixture
    fixture = TestBed.createComponent(AddUserComponent);

    // get test component from the fixture
    component = fixture.componentInstance;
    component.ngOnInit();

  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('form invalid when empty', () => {
        expect(component.addUserForm.valid).toBeFalsy();

  });


    it('Product Name Validation', () => {
        let productname=component.addUserForm.controls['name'];
        expect(productname.valid).toBeFalsy();
        expect(productname.errors['required']).toBeTruthy();
    });

    


});

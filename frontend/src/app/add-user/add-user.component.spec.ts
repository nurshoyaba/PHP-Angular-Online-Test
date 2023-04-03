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

  it('form invalid when empty', () => {
        expect(component.addUserForm.valid).toBeFalsy();

  });


    it('Product Name Validation', () => {
        let productname=component.addUserForm.controls['name'];
        expect(productname.valid).toBeFalsy();
        expect(productname.errors?.['required']).toBeTruthy();
    });

     it('should add items to "addUserForm"', () => {
     expect(component.addUserForm.length).toBe(1); // since you have initialized the variable
     component.name = "Prod1";
     component.state = 1;
     component.zip = 1;
     component.amount = 1;
     component.qty = 1;
     component.item = "Test";
     component.AddUser();  // this will trigger the method
     expect(component.addUserForm.length).toBe(4); // this will show that the entry was added in "this.data"
  }); 

    


});

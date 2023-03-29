import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm, FormControl, FormGroup, Validators,FormArray  } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router } from '@angular/router';


@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.less']
})
export class AddUserComponent implements OnInit {

  
  userdetail: any=[];
  data: any={};
  userMessage: any;
  userStatus: any;
  stringifiedData: any={}
  constructor(private _freeservice:UserService,private router: Router) { }

  ngOnInit(): void {  }
  addUserForm = new FormGroup({
      service: new FormControl("Addnewuser"),
      name: new FormControl("",[Validators.required]),
      state: new FormControl("",[Validators.required]),
      zip: new FormControl("",[Validators.required]),
      amount: new FormControl("",[Validators.required]),
      qty: new FormControl("",[Validators.required]),
      item: new FormControl("",[Validators.required])
  });
  
  AddUser(){
      this._freeservice.saveUser(this.addUserForm.value).subscribe(res=>{
        this.data = res;
        //console.log(this.data);
        
        if(this.data.status == 200){
            this.userStatus=1;
            this.userMessage = this.data.msg;
            setTimeout(() => 
            {
              this.router.navigateByUrl('/Home');
            },
            1000);
        }else{
           this.userStatus=2;
           this.userMessage = this.data.msg;
        }
      });
  }


  get fullname(): FormControl{
     return this.addUserForm.get("name") as FormControl;
  } 
  get state(): FormControl{
     return this.addUserForm.get("state") as FormControl;
  } 
  get zip(): FormControl{
     return this.addUserForm.get("zip") as FormControl;
  } 
  get amount(): FormControl{
     return this.addUserForm.get("amount") as FormControl;
  } 
  get qty(): FormControl{
     return this.addUserForm.get("qty") as FormControl;
  } 
  get item(): FormControl{
     return this.addUserForm.get("item") as FormControl;
  } 


}
export class employeeForm {
  Id: number = 0;
  FirstName: string = "";
  LastName: string = "";
  Email: string = "";
  Address: string = "";
  Phone: string = "";
}

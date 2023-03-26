import { Component, OnInit, ViewChild  } from '@angular/core';
import { UserService } from '../service/user.service';
import { NgForm, FormControl, FormGroup, Validators  } from '@angular/forms';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Router,ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-edit-user',
  templateUrl: './edit-user.component.html',
  styleUrls: ['./edit-user.component.less']
})
export class EditUserComponent implements OnInit {
	
  userdetail: any=[];    
  item_id: any;
  data: any={};
  userMessage: any;
  userStatus: any;
  
  constructor(private _freeservice:UserService,private router: Router,private route: ActivatedRoute) { }
  ngOnInit(): void {
     this.item_id = this.route.snapshot.params['item_id'];
     this.getDetailById();
  }
  editUserForm = new FormGroup({
      service: new FormControl("Edituser"),
      name: new FormControl(""),
      state: new FormControl(""),
      zip: new FormControl(""),
      amount: new FormControl(""),
      qty: new FormControl(""),
      item: new FormControl(""),
      user_id: new FormControl("")
  });

 

  getDetailById() {
	  console.log(this.item_id);
	    this._freeservice.getDetailById(this.item_id).subscribe((data: any) => {
	      if (data != null && data.details != null) {
	        var resultData = data.details;
	        this.userdetail = resultData;      
	        
	      }
	    },
	      (error: any) => { });
	}

   EditUser(){
      this._freeservice.saveUser(this.editUserForm.value).subscribe(res=>{
        this.data = res;
        console.log(this.data);
        if(this.data.status == 200){
            this.userStatus=1;
            this.userMessage = this.data.msg;
            setTimeout(() => 
            {
              this.router.navigateByUrl('/Home');
            },
            3000);
        }else{
           this.userStatus=2;
           this.userMessage = this.data.msg;
        }
      });
  }


  get fullname(): FormControl{
     return this.editUserForm.get("name") as FormControl;
  } 
  get state(): FormControl{
     return this.editUserForm.get("state") as FormControl;
  } 
  get zip(): FormControl{
     return this.editUserForm.get("zip") as FormControl;
  } 
  get amount(): FormControl{
     return this.editUserForm.get("amount") as FormControl;
  } 
  get qty(): FormControl{
     return this.editUserForm.get("qty") as FormControl;
  } 
  get item(): FormControl{
     return this.editUserForm.get("item") as FormControl;
  } 

}
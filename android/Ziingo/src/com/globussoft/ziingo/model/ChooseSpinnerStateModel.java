package com.globussoft.ziingo.model;

public class ChooseSpinnerStateModel {
	
	
		
		public String Spinner_State = "";
		public String Spinner_State_id = "";
		
		public String getSpinner_State() {
			return Spinner_State;
		}

		public void setSpinner_State(String spinner_State) 
		{
			Spinner_State = spinner_State;
		}

		
		public String getSpinner_State_id() {
			return Spinner_State_id;
		}

		public void setSpinner_State_id(String spinner_State_id) {
			Spinner_State_id = spinner_State_id;
		}

		
		

		public ChooseSpinnerStateModel() {
		}

		public ChooseSpinnerStateModel(String Spinner_State, String Spinner_stateId) {
			
			this.Spinner_State = Spinner_State;
			this.Spinner_State_id = Spinner_stateId;
			
		}

		

		@Override
		public String toString() {
			return "ChooseSpinnerStateModel [ Spinner_State = "+ Spinner_State+ ", Spinner_City = " + Spinner_State_id
					+ "]";
		}



	}

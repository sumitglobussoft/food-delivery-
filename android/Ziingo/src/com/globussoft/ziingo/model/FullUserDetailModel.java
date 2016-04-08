package com.globussoft.ziingo.model;

public class FullUserDetailModel {
	
	public String Id = "";
	public String FullName = "";
	public String UserName = "";
	
	
	public String getId() {
		return Id;
	}

	public void setId(String id) {
		Id = id;
	}
	
	public String getFullName() {
		return FullName;
	}

	public void setFullName(String fullName) {
		FullName = fullName;
	}
		
	public String getUserName() {
		return UserName;
	}

	public void setUserName(String userName) {
		UserName = userName;
	}
	
		
	
	@Override
	public String toString() {
		return "FullUserDetailModel [Id=" + Id + ", FullName=" + FullName
				+ ", UserName="	+ UserName + "]";
	}

}

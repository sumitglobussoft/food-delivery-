package com.globussoft.ziingo.model;

import android.content.res.TypedArray;

public class NavDrawerItem {
	
	private String title;
	private TypedArray obtainTypedArray;
    private int icon;
    private String count = "0";
    // boolean to set visiblity of the counter
    private boolean isCounterVisible = false;
     
    public NavDrawerItem(){}
 
    public NavDrawerItem(String title, int icon){
        this.title = title;
        this.icon = icon;
    }
     
    public NavDrawerItem(String title, int icon, boolean isCounterVisible, String count){
        this.title = title;
        this.icon = icon;
        this.isCounterVisible = isCounterVisible;
        this.count = count;
    }
     
    public NavDrawerItem(String title, TypedArray obtainTypedArray) {
		// TODO Auto-generated constructor stub
    	  this.title = title;
    	  this.obtainTypedArray =obtainTypedArray;
	}

	public TypedArray getObtainTypedArray() {
		return obtainTypedArray;
	}

	public void setObtainTypedArray(TypedArray obtainTypedArray) {
		this.obtainTypedArray = obtainTypedArray;
	}

	public String getTitle(){
        return this.title;
    }
     
    public int getIcon(){
        return this.icon;
    }
     
    public String getCount(){
        return this.count;
    }
     
    public boolean getCounterVisibility(){
        return this.isCounterVisible;
    }
     
    public void setTitle(String title){
        this.title = title;
    }
     
    public void setIcon(int icon){
        this.icon = icon;
    }
     
    public void setCount(String count){
        this.count = count;
    }
     
    public void setCounterVisibility(boolean isCounterVisible){
        this.isCounterVisible = isCounterVisible;
    }
    
    @Override
	public String toString() {
		return "NavDrawerItemModel [title=" + title + ", icon=" + icon
				+ ", Count="	+ count + ", isCounterVisible="	+ isCounterVisible + "]";
	}

}

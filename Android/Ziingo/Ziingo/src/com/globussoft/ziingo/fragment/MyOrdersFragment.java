package com.globussoft.ziingo.fragment;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.globussoft.ziingo.R;

public class MyOrdersFragment extends Fragment 
{
	
	 @Override
	    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) 
	 {
	  
	        View rootView = inflater.inflate(R.layout.fragment_myorders, container, false);
	        InitView(); 
	        return rootView;
	        
	      
	    }

	private void InitView()
	{
		// TODO Auto-generated method stub
		
	}
	 
	

}
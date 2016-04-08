/*package com.globussoft.ziingo;

import java.util.ArrayList;
import java.util.List;

import com.globussoft.ziingo.adapter.ChooseCountryAdapter;
import com.globussoft.ziingo.adapter.RestaurantListAdapter;
import com.globussoft.ziingo.adapter.TypeLocAdapter;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.model.TypeLocModel;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class Type_Location extends FragmentActivity {
	
	public List<TypeLocModel> reslocList = new ArrayList<TypeLocModel>(); ;
	public TypeLocAdapter tlAdapter;
	public ListView reslocListView;
	public RelativeLayout rel_use_my_loc;
	private ImageView bck_btn;
	private EditText enter_loc;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
	    setContentView(R.layout.type_location);
	    
	    Initui();
	}
	
	protected void Initui(){
		
		 rel_use_my_loc = (RelativeLayout) findViewById(R.id.rel_use_my_loc);
		 enter_loc = (EditText) findViewById(R.id.enter_loc);
		 bck_btn = (ImageView) findViewById(R.id.bk_btn);
		 reslocListView = (ListView) findViewById(R.id.list_rec_loc);
		 
		 Singleton.location = enter_loc.getText().toString();
		 
		 tlAdapter = new TypeLocAdapter(getApplicationContext(), reslocList);
		 reslocListView.setAdapter(tlAdapter);
			genRecLocList();  	
		
		
			System.out.println("Singleton.location >> "+ Singleton.location);
		
		rel_use_my_loc.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub			
				System.out.println(" Use My Location");				
				Intent i = new Intent(Type_Location.this, Location_Fetch.class);
				startActivity(i);
				
			}
		});
	
		
		bck_btn.setOnClickListener(new OnClickListener() {			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub				
				onBackPressed();
				
			}
		});
	}
	
	public void genRecLocList()
	{
		TypeLocModel reslocmodelList = new TypeLocModel();
		reslocmodelList.setLocation(Singleton.location);
		reslocList.add(reslocmodelList);
	        tlAdapter.notifyDataSetChanged();
	}

}
*/
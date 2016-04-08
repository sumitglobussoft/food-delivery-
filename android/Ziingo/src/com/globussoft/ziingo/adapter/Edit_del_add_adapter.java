package com.globussoft.ziingo.adapter;

import java.util.List;

import android.app.Activity;
import android.app.Application;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.DeliveryAddress_Activity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.fragment.FoodsFragment;
import com.globussoft.ziingo.model.Edit_del_add_model;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.Singleton;

public class Edit_del_add_adapter extends BaseAdapter {
	private Context context;
	private LayoutInflater inflater;
	public  List<Edit_del_add_model> del_addListItems;
	

	public Edit_del_add_adapter(Context context,
			List<Edit_del_add_model> del_addListItems) {
		this.context = context;
		this.del_addListItems = del_addListItems;
		
		//System.out.println("No. of restaurants open >>>>>> "+restaurantListItems.size());
	}

	@Override
	public int getCount() {
		
		//Singleton.Restaurant_cnt = Integer.toString(restaurantListItems.size());
		
		return del_addListItems.size();
	}
	
	
	@Override
	public Object getItem(int location) {
		return del_addListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {

		if (inflater == null)
			inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.edit_del_add_list_item, null);

		
		TextView list_del_fn = (TextView) convertView.findViewById(R.id.list_del_fn);
		TextView list_del_add = (TextView) convertView.findViewById(R.id.list_del_add);
		TextView list_del_loc = (TextView) convertView.findViewById(R.id.list_del_loc);
		TextView list_del_city = (TextView) convertView.findViewById(R.id.list_del_city);
		TextView list_del_citypin = (TextView) convertView.findViewById(R.id.list_del_citypin);		
		TextView list_del_state = (TextView) convertView.findViewById(R.id.list_del_state);	
		TextView list_del_mobile = (TextView) convertView.findViewById(R.id.list_del_mobile);		
		TextView list_del_editaddress = (TextView) convertView.findViewById(R.id.list_del_editaddress);	

		
		Edit_del_add_model m = del_addListItems.get(position);
		
		list_del_fn.setText(m.getDel_userName());
		list_del_add.setText(m.getDel_address1());
		list_del_loc.setText(m.getDel_location());
		list_del_city.setText(m.getDel_city()+ " - ");
		list_del_citypin.setText(m.getDel_pincode());
		list_del_state.setText(m.getDel_state());
		list_del_mobile.setText("Mobile: "+m.getDel_contact_number());
		
		list_del_editaddress.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				Singleton.del_address_ID = del_addListItems.get(position).getDel_address_ID();
				Singleton.delFullname = del_addListItems.get(position).getDel_userName();
				Singleton.delPh_num = del_addListItems.get(position).getDel_contact_number();
				Singleton.delAddress = del_addListItems.get(position).getDel_address1();
				Singleton.delOP_Address = del_addListItems.get(position).getDel_address2();
				Singleton.delLandMark = del_addListItems.get(position).getDel_landmark();
				Singleton.delLoc = del_addListItems.get(position).getDel_location();
				Singleton.delpincode = del_addListItems.get(position).getDel_pincode();
				Singleton.delCity = del_addListItems.get(position).getDel_city();
				
				System.out.println("DDDDD Singleton.delFullname >>> "+ Singleton.delFullname);
				
				Intent i = new Intent(context, DeliveryAddress_Activity.class);
				i.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
				context.startActivity(i);
				
			}
		});
		
		return convertView;
	}

}

package com.globussoft.ziingo.adapter;

import java.util.List;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.model.OrderHistoryModel;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ExpandableListView;
import android.widget.TextView;

public class Order_History_adapter extends BaseAdapter{
	private Activity activity;
	private LayoutInflater inflater;
	public  List<OrderHistoryModel> orderHistoryListItems;
	
	public Order_History_adapter(Activity activity, List<OrderHistoryModel> orderHistoryListItems) 
	{
		this.activity = activity;
		this.orderHistoryListItems = orderHistoryListItems;
		
	}

	@Override
	public int getCount() 
	{				
		return orderHistoryListItems.size();
	}
	
	
	@Override
	public Object getItem(int location) 
	{
		return orderHistoryListItems.get(location);
	}

	@Override
	public long getItemId(int position)
	{
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {

		if (inflater == null)
			inflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.fragment_myorders_list, null);		
		
		TextView hotel_name = (TextView) convertView.findViewById(R.id.his_htl_nm);
		TextView order_date = (TextView) convertView.findViewById(R.id.his_date);
		TextView hotel_add = (TextView) convertView.findViewById(R.id.his_add);		
		TextView order_total = (TextView) convertView.findViewById(R.id.his_total);	
				
		OrderHistoryModel m = orderHistoryListItems.get(position);
				
		hotel_name.setText(m.getHistory_HotelName());
		hotel_add.setText(m.getHistory_HotelAddress());
		order_date.setText(m.getHistory_OrderDate());
		order_total.setText("Total: " + Singleton.currency +" "+ m.getHistory_OrderTotal());
		
		return convertView;
	}

}

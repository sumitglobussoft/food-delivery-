package com.globussoft.ziingo.adapter;

import java.util.List;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.model.RestaurantListModel;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

public class HorizontalListAdapter extends BaseAdapter {

	private Activity activity;
	private LayoutInflater inflater;
	//private List<HorizontalList_Model> horizontalListItems;
	private List<RestaurantListModel> restListModel;
	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	public HorizontalListAdapter(Activity activity,
			List<RestaurantListModel> restListModel) {
		this.activity = activity;
		//this.horizontalListItems = horizontalListItems;
		this.restListModel = restListModel;
		System.out.println(restListModel.size());
	}

	@Override
	public int getCount() {
		return restListModel.size();
	}

	@Override
	public Object getItem(int location) {
		return restListModel.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		// TODO Auto-generated method stub


		if (inflater == null)
			inflater = (LayoutInflater) activity
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.horizontalimage, null);

		if (imageLoader == null)
			imageLoader = AppController.getInstance().getImageLoader();
		
		NetworkImageView thumbNail = (NetworkImageView) convertView.findViewById(R.id.thumbnail);
		TextView restaurant_name = (TextView) convertView.findViewById(R.id.restaurant_name);
				

		// getting movie data for the row
		RestaurantListModel m = restListModel.get(position);

		// thumbnail image
		thumbNail.setImageUrl(m.getThumbnailUrl(), imageLoader);

		// Rest_name
		restaurant_name.setText(m.getRest_name());
		
		return convertView;
	
	}

}

package com.globussoft.ziingo.adapter;

import java.util.List;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.fragment.FoodsFragment;
import com.globussoft.ziingo.model.RestaurantListModel;
import com.globussoft.ziingo.utills.Singleton;

public class RestaurantListAdapter extends BaseAdapter {
	private Activity activity;
	private LayoutInflater inflater;
	public  List<RestaurantListModel> restaurantListItems;
	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	public RestaurantListAdapter(Activity activity,
			List<RestaurantListModel> restaurantListItems) {
		this.activity = activity;
		this.restaurantListItems = restaurantListItems;
		
		//System.out.println("No. of restaurants open >>>>>> "+restaurantListItems.size());
	}

	@Override
	public int getCount() {
		
		//Singleton.Restaurant_cnt = Integer.toString(restaurantListItems.size());
		
		return restaurantListItems.size();
	}
	
	
	@Override
	public Object getItem(int location) {
		return restaurantListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {

		if (inflater == null)
			inflater = (LayoutInflater) activity
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.fragment_foods_adapter, null);

		if (imageLoader == null)
			imageLoader = AppController.getInstance().getImageLoader();
		
		NetworkImageView thumbNail = (NetworkImageView) convertView.findViewById(R.id.thumbnail);
		TextView restaurant_name = (TextView) convertView.findViewById(R.id.restaurant_name);
		TextView restaurant_add = (TextView) convertView.findViewById(R.id.restaurant_add);
		//TextView reviews_count = (TextView) convertView.findViewById(R.id.reviews_count);
		TextView cuisine = (TextView) convertView.findViewById(R.id.cuisine);		
		TextView min_order = (TextView) convertView.findViewById(R.id.rstminprice);		

		
		RestaurantListModel m = restaurantListItems.get(position);
		
		thumbNail.setImageUrl(m.getThumbnailUrl(), imageLoader);
		restaurant_name.setText(m.getRest_name());
		restaurant_add.setText(m.getRest_add());
		cuisine.setText(m.getCuisine());
		min_order.setText(Singleton.currency +" "+ m.getMin_order());

		// Reviews
		//reviews.setText("Rating: " + String.valueOf(m.getreviews()));

		// Cuisine
		/*String cuisineStr = "";
		for (String str : m.getCuisine()) {
			cuisineStr += str + ", ";
		} 
		cuisineStr = cuisineStr.length() > 0 ? cuisineStr.substring(0,
				cuisineStr.length() - 2) : cuisineStr;
		cuisine.setText(cuisineStr);
		*/
		return convertView;
	}

}

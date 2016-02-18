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
import com.globussoft.ziingo.model.MenuListModel;

public class MenuListAdapter extends BaseAdapter {
	

	private Activity activity;
	private LayoutInflater inflater;
	private List<MenuListModel> menuListItems;
//	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	public MenuListAdapter(Activity activity,
			List<MenuListModel> menuListItems) {
		this.activity = activity;
		this.menuListItems = menuListItems;
	}

	@Override
	public int getCount() {
		return menuListItems.size();
	}

	@Override
	public Object getItem(int location) {
		return menuListItems.get(location);
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
			convertView = inflater.inflate(R.layout.food_menu_fragment, null);

		/*if (imageLoader == null)
			imageLoader = AppController.getInstance().getImageLoader();
		*/
		//NetworkImageView thumbNail = (NetworkImageView) convertView.findViewById(R.id.thumbnail);
		TextView category = (TextView) convertView.findViewById(R.id.category);
		//TextView food_item = (TextView) convertView.findViewById(R.id.food_item);
		
		

		// getting product data for the row
		MenuListModel m = menuListItems.get(position);

		// thumbnail image
		//thumbNail.setImageUrl(m.getThumbnailUrl(), imageLoader);

		// Food_Category
		category.setText(m.getCategory_Name());
		
		// Food_Item
		//food_item.setText(m.getProduct_Name());

		// Reviews
		//reviews.setText("Rating: " + String.valueOf(m.getreviews()));
		

		return convertView;
	}



}

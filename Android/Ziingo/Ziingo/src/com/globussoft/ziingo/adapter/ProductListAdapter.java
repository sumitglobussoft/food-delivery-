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
import com.globussoft.ziingo.model.ProductListModel;
import com.globussoft.ziingo.utills.Singleton;

public class ProductListAdapter extends BaseAdapter {
	

	private Activity activity;
	private LayoutInflater inflater;
	private List<ProductListModel> productListItems;
	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	public ProductListAdapter(Activity activity,
			List<ProductListModel> productListItems) {
		this.activity = activity;
		this.productListItems = productListItems;
	}

	@Override
	public int getCount() {
		return productListItems.size();
	}

	@Override
	public Object getItem(int location) {
		return productListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {

		if (inflater == null)
			inflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.product_list_fragment, null);

		if (imageLoader == null)
			imageLoader = AppController.getInstance().getImageLoader();
		
		NetworkImageView prod_image = (NetworkImageView) convertView.findViewById(R.id.prod_img);
		TextView food_item = (TextView) convertView.findViewById(R.id.fooditem);
		TextView food_cost = (TextView) convertView.findViewById(R.id.product_cost);
		
		ProductListModel m = productListItems.get(position);
		prod_image.setImageUrl(m.getProduct_image(), imageLoader);
		food_item.setText(m.getProduct_name());
		food_cost.setText(Singleton.currency +" " + m.getCost());

		// Reviews
		//reviews.setText("Rating: " + String.valueOf(m.getreviews()));
		

		return convertView;
	}



}

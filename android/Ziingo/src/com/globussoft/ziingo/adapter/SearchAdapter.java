package com.globussoft.ziingo.adapter;

import java.util.ArrayList;
import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.RestaurantListModel;

public class SearchAdapter extends BaseAdapter implements Filterable {/*
	

	private Context context;
	private List<RestaurantListModel> heightList;  // create separate model for search (foods and groceries)
	 
	TextView height;
	
	private LayoutInflater inflater;
	 
	public SearchAdapter(Context context, List<RestaurantListModel> bpm)
	{
		this.context=context;
		this.heightList = bpm;
		 
	}

	@Override
	public int getCount() {
		return heightList.size();
	}

	@Override
	public Object getItem(int position) 
	{
		return heightList.get(position);
	}

	@Override
	public long getItemId(int position) 
	{
		return position;
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {

		
		
		if (inflater == null)
			inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null) 
			convertView = inflater.inflate(R.layout.dialog_search_item, null);

		height = (TextView) convertView.findViewById(R.id.heighttextview);
		
		height.setText(heightList.get(position).getRest_name());
	
		return convertView;
	}

	
*/
	
	private List<RestaurantListModel>originalData = null;
	private List<RestaurantListModel> filteredData = null;
	private LayoutInflater mInflater;
	private ItemFilter mFilter = new ItemFilter();
	private Context context;
	
	public SearchAdapter(Context context, List<RestaurantListModel> rlm) {
		this.filteredData = rlm ;
		this.originalData = rlm ;
    	mInflater = LayoutInflater.from(context);
    }

	public int getCount() {
		return filteredData.size();
	}

	public Object getItem(int position) {
		return filteredData.get(position);
	}

	public long getItemId(int position) {
		return position;
	}

    public View getView(int position, View convertView, ViewGroup parent) {
       /* // A ViewHolder keeps references to children views to avoid unnecessary calls
        // to findViewById() on each row.
        ViewHolder holder;

        // When convertView is not null, we can reuse it directly, there is no need
        // to reinflate it. We only inflate a new View when the convertView supplied
        // by ListView is null.
        if (convertView == null) {
            convertView = mInflater.inflate(R.layout.dialog_search_item, null);

            // Creates a ViewHolder and store references to the two children views
            // we want to bind data to.
            holder = new ViewHolder();
            holder.text = (TextView) convertView.findViewById(R.id.heighttextview);

            // Bind the data efficiently with the holder.

            convertView.setTag(holder);
        } else {
            // Get the ViewHolder back to get fast access to the TextView
            // and the ImageView.
            holder = (ViewHolder) convertView.getTag();
        }

        // If weren't re-ordering this you could rely on what you set last time
        holder.text.setText((CharSequence) filteredData.get(position));*/
    	
    	if (mInflater == null)
    		mInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null) 
			convertView = mInflater.inflate(R.layout.dialog_search_item, null);

		TextView height = (TextView) convertView.findViewById(R.id.heighttextview);
		
		height.setText(filteredData.get(position).getRest_name());

        return convertView;
    }
	
    static class ViewHolder {
        TextView text;
    }

	public Filter getFilter() {
		return mFilter;
	}

	private class ItemFilter extends Filter {
		@Override
		protected FilterResults performFiltering(CharSequence constraint) {
			
			String filterString = constraint.toString().toLowerCase();
			
			FilterResults results = new FilterResults();
			
			final List<RestaurantListModel> list = originalData;

			int count = list.size();
			final ArrayList<RestaurantListModel> nlist = new ArrayList<RestaurantListModel>(count);

			RestaurantListModel filterableString ;
			
			for (int i = 0; i < count; i++) 
			{
				filterableString = list.get(i);
				if (filterableString.getRest_name().toLowerCase().contains(filterString)) 
				{
					nlist.add(filterableString);
				}
			}
			
			results.values = nlist;
			results.count = nlist.size();

			return results;
		}

		@SuppressWarnings("unchecked")
		@Override
		protected void publishResults(CharSequence constraint, FilterResults results) {
			filteredData = (List<RestaurantListModel>) results.values;
			notifyDataSetChanged();
		}

	}
}

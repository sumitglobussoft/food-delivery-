package com.globussoft.ziingo.adapter;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;

import com.globussoft.ziingo.fragment.HistoryOrders;
import com.globussoft.ziingo.fragment.OnGoingOrders;

public class MyOrdersViewPagerAdapter  extends FragmentPagerAdapter {

	private static final String[] CONTENT = new String[] { "Ongoing", "History" };

	public MyOrdersViewPagerAdapter(FragmentManager fm) {
		super(fm);
	}

	@Override
	public Fragment getItem(int arg0) {
		// TODO Auto-generated method stub
		switch (arg0) {
		case 0:
			return new OnGoingOrders();
		case 1:
			return new HistoryOrders();

		}
		return null;
	}

	@Override
	public CharSequence getPageTitle(int position) {
		return CONTENT[position % CONTENT.length];
	}

	@Override
	public int getCount() {
		return 2;
	}
	
	


}

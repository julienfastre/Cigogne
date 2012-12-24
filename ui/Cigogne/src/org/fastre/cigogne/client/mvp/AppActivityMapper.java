package org.fastre.cigogne.client.mvp;

import org.fastre.cigogne.client.ClientFactory;
import org.fastre.cigogne.client.activities.HomePageActivity;

import com.google.gwt.activity.shared.Activity;
import com.google.gwt.activity.shared.ActivityMapper;
import com.google.gwt.place.shared.Place;

public class AppActivityMapper implements ActivityMapper {
	
	private ClientFactory clientFactory;
	
	public AppActivityMapper(ClientFactory clientFactory) {
		this.clientFactory = clientFactory;
	}

	@Override
	public Activity getActivity(Place place) {
		return new HomePageActivity(this.clientFactory);
	}

}
